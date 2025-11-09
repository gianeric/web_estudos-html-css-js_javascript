# ENGLISH INSIGHT GEN AI

**Projeto pessoal para estudos:** corretor de frases em inglês usando **Python** (backend) e **JavaScript** (frontend), integrado ao **Google Gemini AI**.

---

## 🛠 Tecnologias

[![Python](https://img.shields.io/badge/Python-3.12-blue?logo=python&logoColor=white)](https://www.python.org/)  
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)  
[![Gemini AI](https://img.shields.io/badge/GeminiAI-Google-lightgrey)](https://cloud.google.com/vertex-ai)  
[![AWS](https://img.shields.io/badge/AWS-Serverless-orange?logo=amazon-aws&logoColor=white)](https://aws.amazon.com/)  
[![AWS SAM CLI](https://img.shields.io/badge/AWS%20SAM-CLI-red?logo=amazon-aws&logoColor=white)](https://docs.aws.amazon.com/serverless-application-model/latest/developerguide/what-is-sam.html)

---

## 🚀 Rodando o backend localmente

### 1️⃣ Clone o projeto

```bash
git clone https://github.com/gianeric/english-insight-gen-ai.git
cd english-insight-gen-ai/backend
```

### 2️⃣ Iniciar o LocalStack (Docker)

LocalStack simula os serviços da AWS localmente.

```bash
cd backend/docker
docker-compose up -d
```

Referência: [LocalStack GitHub](https://github.com/localstack/localstack)

### 3️⃣ Configurar variáveis de ambiente para o GEMINI AI

No diretório backend/app crie o arquivo env.json (não commitá-lo):

```json
{
  "ApiLambda": {
    "GEMINI_API_KEY": "SUA_CHAVE_AQUI"
  }
}
```

💡 Dica: Esse arquivo será usado pelo SAM para injetar a chave da sua conta Gemini na Lambda durante o desenvolvimento local.

### 4️⃣ Instalar AWS SAM CLI (Windows)

```bash
choco install awssamcli
```

### 5️⃣ Compilar a Lambda

No diretório backend/app:

```bash
sam build
```

### 6️⃣ Rodar a Lambda localmente

```bash
sam local start-api --env-vars env.json
```

O endpoint ficará disponível em:

```bash
http://localhost:3000/corrector
```

### 7️⃣ Testando a API

Você pode usar o Postman, Insomnia ou qualquer outra ferramenta HTTP.

Método: POST
URL: http://localhost:3000/corrector
Body (JSON):

```json
{
  "sentence": "He don't like the movie."
}
```

Resposta esperada:

```json
{
  "correction": "Correct: He doesn't like the movie. Explicação curta: Para a terceira pessoa do singular (he, she, it), usa-se 'doesn't' (does not) na forma negativa do Simple Present, não 'don't'."
}
```

### 8️⃣ Debug no VSCode

Se quiser depurar a Lambda localmente com VSCode:

No diretório backend/app, crie o arquivo .env (não commitá-lo):

```bash
GEMINI_API_KEY=SUA_CHAVE_AQUI
```

Descomente esse trecho de código em backend\app\lambda_function.py

```python
if __name__ == "__main__":
    setence = {'body': '{\n\t"sentence": "She don\'t like the movie."\n}'}
    handler(setence, "context")
```

Utilize o launch.json do VSCode em ".vscode\lauch.json"

Assim, você consegue depurar a Lambda como se estivesse rodando localmente, podendo inspecionar variáveis e logs.

---

💡 Dicas

Sempre mantenha sua chave do Gemini fora do GitHub.

LocalStack é opcional, mas ajuda a simular serviços AWS sem gastar créditos.

Timeout para chamadas à API Gemini pode variar; configure seu template.yml com um tempo maior (ex: 30s).
