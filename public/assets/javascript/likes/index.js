export function likes() {
  const likeButton = document.getElementById("like-button");

  if (likeButton) {
    const postIdInput = document.getElementById("post-id");
    const postId = postIdInput.value;

    async function fetchPostLikesNumber() {
      const response = await fetch(`/post-likes?id=${postId}`);
      const data = await response.json();
      return data.likes;
    }

    async function fetchIsLike() {
      const response = await fetch(`/post-like?id=${postId}`);
      const data = await response.json();
      return data.like;
    }

    async function setLikesValue() {
      const likesNode = document.getElementById("likes-number");
      const likes = await fetchPostLikesNumber();
      likesNode.textContent = likes;
    }

    async function setIsLike() {
      const likeThumbNode = document.getElementById("like-thumb");
      const like = await fetchIsLike();
      if (like) {
        likeThumbNode.className = "bi-hand-thumbs-up-fill";
      } else {
        likeThumbNode.className = "bi-hand-thumbs-up";
      }
    }

    async function like() {
      const response = await fetch(`/post-like?id=${postId}`, {
        method: "POST",
        body: JSON.stringify({ id: postId }),
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
      });

      const data = await response.json();

      if (data.error && data.error === "notAuthenticated") {
        alert("You have to be authenticated");
      }
      if (data.success) {
        setLikesValue();
        setIsLike();
      }
    }

    setLikesValue();
    setIsLike();

    likeButton.addEventListener("click", like);
  }
}
