import os
from dotenv import load_dotenv

class AuthGemini:
    def __init__(self):
        if not os.getenv("GEMINI_API_KEY"):
            load_dotenv()

    def authorization(self):
        gemini_key = os.getenv("GEMINI_API_KEY")
        if not gemini_key:
            raise ValueError("Variável de ambiente GEMINI_API_KEY não encontrada.")
        return gemini_key
