/**
 * Spinner Module - Componente reutilizável para loading
 * Uso: import { createLoadingSpinner, showSpinner, hideSpinner } from "./spinner.js";
 */

/**
 * Cria um elemento spinner de loading
 * @returns {HTMLElement} Elemento do spinner
 */
export function createLoadingSpinner() {
  const spinnerDiv = document.createElement("div");
  spinnerDiv.classList.add("loading-spinner");
  spinnerDiv.setAttribute("id", "spinner-container");
  spinnerDiv.innerHTML = `
    <div class="spinner"></div>
    <p class="loading-text">Aguardando resposta...</p>
  `;
  return spinnerDiv;
}

/**
 * Mostra o spinner em um container específico
 * @param {HTMLElement} container - Container onde inserir o spinner
 * @returns {HTMLElement} Elemento do spinner
 */
export function showSpinner(container) {
  // Remove spinner anterior se existir
  const existingSpinner = container.querySelector(".loading-spinner");
  if (existingSpinner) {
    existingSpinner.remove();
  }

  const spinner = createLoadingSpinner();
  container.appendChild(spinner);
  return spinner;
}

/**
 * Remove o spinner de um container
 * @param {HTMLElement} container - Container contendo o spinner
 */
export function hideSpinner(container) {
  const spinner = container.querySelector(".loading-spinner");
  if (spinner) {
    spinner.remove();
  }
}

/**
 * Remove todos os spinners da página
 */
export function hideAllSpinners() {
  const spinners = document.querySelectorAll(".loading-spinner");
  spinners.forEach(spinner => spinner.remove());
}
