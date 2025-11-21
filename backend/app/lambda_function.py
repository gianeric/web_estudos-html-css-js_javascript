import json
from configs.logger import get_logger
from configs.auth_gemini import AuthGemini
from utils.mappers.event_mapper import EventMapper
from services.corrector_service import CorrectorService
from google import genai

headers = {
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET,POST,OPTIONS",
    "Access-Control-Allow-Headers": "Content-Type,Authorization",
    "Access-Control-Allow-Credentials": "true",
    "Content-Type": "application/json"
}

def parse_clean_gemini_response(raw):
    try:
        if isinstance(raw, (dict, list)):
            text = json.dumps(raw, ensure_ascii=False)
        else:
            text = str(raw)
            try:
                parsed = json.loads(text)
                text = json.dumps(parsed, ensure_ascii=False)
            except Exception:
                try:
                    text = bytes(text, "utf-8").decode("unicode_escape")
                except Exception:
                    pass

        text = text.replace('\\n', ' ').replace('\n', ' ').strip()
        text = text.replace("\\'", "'").replace('\\"', '"')
        return text
    except Exception:
        return str(raw)

class LambdaEnglishCorrector:
    def __init__(self):
        self.logger = get_logger(None)
        self.logger.info("[LambdaEnglishCorrector] Inicializando Lambda.")

    def correct_sentence(self, event, context):
        self.logger.info("[LambdaEnglishCorrector] Manipulando evento.")

        http_method = event.get("httpMethod", "")
        if http_method == "OPTIONS":
            return {
                "statusCode": 204,
                "headers": headers,
                "body": ""
            }

        mapper = EventMapper()
        body = mapper.map_event_to_dto(event)
        sentence = body.get("sentence", "")

        if not sentence:
            self.logger.error(f"[LambdaEnglishCorrector] Nenhuma frase fornecida.")
            return {
                "statusCode": 400,
                "headers": headers,
                "body": json.dumps({"error": "Nenhuma frase fornecida."})
            }
        
        try:
            corrector = CorrectorService()
            auth_gemini = AuthGemini()
            client = genai.Client(api_key=auth_gemini.authorization())

            gemini_response = client.models.generate_content(
                model="gemini-2.5-flash",
                contents=f"{corrector.prompt()}\n\nFrase: {sentence}"
            )
            
            cleaned = parse_clean_gemini_response(gemini_response.text)

            self.logger.info("[LambdaEnglishCorrector] Correção gerada com sucesso.")

            return{
                "statusCode": 200,
                "headers": headers,
                "body": json.dumps(
                    {"correction": cleaned},
                    ensure_ascii=False
                )
            }
        except ConnectionError as ce:
            self.logger.error(f"[LambdaEnglishCorrector] Erro ao conectar no serviço externo: {ce}")
            return {
                "statusCode": 503,
                "headers": headers,
                "body": json.dumps({"error": "Erro ao conectar no serviço externo."})
            }
        
        except Exception as e:
            self.logger.error(f"[LambdaEnglishCorrector] Erro interno ao processar a frase: {e}")
            return {
                "statusCode": 500,
                "headers": headers,
                "body": json.dumps({"error": "Erro interno ao processar a frase."})
            }

lambda_instance = LambdaEnglishCorrector()

def handler(event, context):    
    return lambda_instance.correct_sentence(event, context)

if __name__ == "__main__":
    setence = {'body': '{\n\t"sentence": "She don\'t like the movie."\n}'}
    handler(setence, "context")
