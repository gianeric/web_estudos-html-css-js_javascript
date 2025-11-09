import os
from configs.logger import get_logger
from configs.auth_gemini import AuthGemini
from services.corrector_service import CorrectorService
from google import genai
from dotenv import load_dotenv

class LambdaEnglishCorrector:
    def __init__(self):
        self.logger = get_logger(None)
        self.logger.info("[LambdaEnglishCorrector] Inicializando Lambda.")

    def handle(self, event, context):
        self.logger.info("[LambdaEnglishCorrector] Manipulando evento.")
        sentence = event.get("sentence", "")
        if not sentence:
            self.logger.error("[LambdaEnglishCorrector] Nenhuma frase fornecida no evento.")
            return {"error": "Nenhuma frase fornecida."}
        
        try:
            corrector = CorrectorService()
            auth_gemini = AuthGemini()
            client = genai.Client(api_key=auth_gemini.authorization())

            response = client.models.generate_content(
                model="gemini-2.5-flash",
                contents=f"{corrector.prompt()}\n\nFrase: {sentence}"
            )
            
            self.logger.info("[LambdaEnglishCorrector] Correção gerada com sucesso.")
            
            return {"correction": response.text}
        except Exception as e:
            self.logger.error("[LambdaEnglishCorrector] Erro ao processar a frase.", error=str(e))
            return {"error": str(e)}

lambda_instance = LambdaEnglishCorrector()

def lambda_handler(event, context):    
    return lambda_instance.handle(event, context)

if __name__ == "__main__":
    setence = {
        "sentence": "She don't like the movie."
    }
    lambda_handler(setence, "context")
