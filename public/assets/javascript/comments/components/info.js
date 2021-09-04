export function info(userId, avatar, username, createdDate) {
  const wrapper = document.createElement("div");
  wrapper.className = "d-flex mb-2";

  const avatarImg = document.createElement("img");
  const avatarWrapper = document.createElement("div");

  avatarImg.setAttribute("src", avatar);
  avatarImg.className = "image-cover avatar";

  avatarWrapper.className = "avatar-wrapper-small";

  avatarWrapper.appendChild(avatarImg);

  const infoWrapper = document.createElement("div");
  infoWrapper.className = "ms-2";

  const dateParagraph = document.createElement("small");
  const usernameParagraph = document.createElement("small");
  const userLink = document.createElement("a");

  dateParagraph.className = "d-block text-muted";
  
  userLink.setAttribute('href', `/user?id=${userId}`);

  dateParagraph.textContent = createdDate;
  usernameParagraph.textContent = username;

  userLink.appendChild(usernameParagraph);

  infoWrapper.appendChild(userLink);
  infoWrapper.appendChild(dateParagraph);

  wrapper.appendChild(avatarWrapper);
  wrapper.appendChild(infoWrapper);

  return wrapper;
}
