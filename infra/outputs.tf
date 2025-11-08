output "lambda_url" {
  description = "URL da Lambda Function"
  value       = aws_lambda_function_url.lambda_url.function_url
}
