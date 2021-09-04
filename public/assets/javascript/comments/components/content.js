export function content(content) {
  const element = document.createElement("div");
  element.setAttribute('style', 'white-space: pre-line;')
  element.textContent = content;
  return element;
}
