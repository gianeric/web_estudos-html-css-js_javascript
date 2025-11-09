import os
from dotenv import load_dotenv

class AuthGemini:
    def __init__(self):
        pass

    def authorization(self):
        load_dotenv()
        GEMINI_API_KEY = os.getenv("GEMINI_API_KEY")
        if not GEMINI_API_KEY:
            raise ValueError("GEMINI_API_KEY is not set in environment variables.")
        return GEMINI_API_KEY
