!/bin/bash

set -e

#Isso instrui o aws CLI a não usar pager (dar enter nas mensagens)
export AWS_PAGER=""

echo "🚀 Iniciando processo de deploy da Lambda..."

# Caminhos
APP_DIR="app"
BUILD_DIR="build"
ZIP_FILE="function.zip"
LAMBDA_NAME="my-function"
HANDLER="lambda_function.handler"
ROLE_ARN="arn:aws:iam::000000000000:role/lambda-role"

# 1. Limpa build anterior
echo "🧹 Limpando build anterior..."
rm -rf $BUILD_DIR
mkdir $BUILD_DIR

# 2. Remove ZIP anterior se existir
echo "🔄 Limpando arquivo zip anterior..."
rm -f "$ZIP_FILE"

# 3. Instala dependências no diretório build/package
echo "📦 Instalando dependências..."
pip install -r $APP_DIR/requirements.txt --target $BUILD_DIR

# 4. Copia código da Lambda (mantém estrutura de pastas)
echo "📁 Copiando código da Lambda..."
cp -r $APP_DIR/* $BUILD_DIR/

# 5. Gera o ZIP
echo "🗜️ Gerando arquivo ZIP..."
cd $BUILD_DIR
zip -r9 ../$ZIP_FILE . > /dev/null
cd ..

# 6. Exclui pasta build
echo "🧹 Limpando build anterior..."
rm -rf $BUILD_DIR

# 7. FIM Deploy
echo "✅ Deploy package '$ZIP_FILE' criado com sucesso!"

# 8. Remove a função anterior, se já existir
echo "🧹 Removendo função anterior (se existir)..."
aws --endpoint-url=http://localhost:4566 lambda delete-function --function-name "$LAMBDA_NAME" 2>/dev/null || true

# 9. Cria a função
echo "🚀 Criando função Lambda no LocalStack..."
aws --endpoint-url=http://localhost:4566 lambda create-function \
  --function-name "$LAMBDA_NAME" \
  --runtime python3.12 \
  --handler "$HANDLER" \
  --role "$ROLE_ARN" \
  --zip-file "fileb://$ZIP_FILE"

# 10. Invoca a função
echo "✅ Invocando função Lambda..."
aws --endpoint-url=http://localhost:4566 lambda invoke \
  --function-name "$LAMBDA_NAME" \
  --payload '{ "key": "value" }' \
  --cli-binary-format raw-in-base64-out \
  _response.json

# 11. Resposta da chamada da função lambda
echo "📄 Resposta:"
cat _response.json

# 12. Remove ZIP
echo "🔄 Limpando arquivo zip anterior..."
rm -f "$ZIP_FILE"

echo -e "\n✅ Pronto!"
