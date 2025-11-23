import { sendMessageToApi } from "./api.js";
import { showSpinner, hideSpinner } from "./spinner.js";

const input = document.getElementById("input_chat");
const button = document.getElementById("btn_send");
const messages = document.querySelector(".messages");

button.addEventListener("click", async () => {
  const text = input.value.trim();
  if (text === "") return;

  button.disabled = true;
  const spinner = showSpinner(messages);

  setTimeout(() => {
    spinner.scrollIntoView({ behavior: "smooth", block: "center" });
  }, 100);

  const apiResponse = await sendMessageToApi(text);

  hideSpinner(messages);
  button.disabled = false;

  if (apiResponse && apiResponse.correction) {
    const msgDiv = document.createElement("div");
    msgDiv.classList.add("message-response", "mb-2");
    msgDiv.innerHTML = `
      <p class="correction"><strong>Correção:</strong> ${
        apiResponse.correction
      }</p>
      ${
        apiResponse.explanation
          ? `<p class="explanation"><em>${apiResponse.explanation}</em></p>`
          : ""
      }
    `;
    messages.appendChild(msgDiv);

    setTimeout(() => {
      msgDiv.scrollIntoView({ behavior: "smooth", block: "center" });
    }, 100);
  } else {
    const errorDiv = document.createElement("div");
    errorDiv.classList.add("message-error", "mb-2");
    errorDiv.textContent = "Erro ao obter resposta. Tente novamente.";
    messages.appendChild(errorDiv);

    setTimeout(() => {
      errorDiv.scrollIntoView({ behavior: "smooth", block: "center" });
    }, 100);
  }

  input.value = "";
});
