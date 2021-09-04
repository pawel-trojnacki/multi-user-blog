import { fetchPostLikesNumber } from "./functions/fetchPostLikeNumber";
import { fetchIsLike } from "./functions/fetchIsLike";
import { saveLike } from "./functions/saveLike";

export function likes() {
  const likeButton = document.getElementById("like-button");

  if (likeButton) {
    const postIdInput = document.getElementById("post-id");
    const postId = postIdInput.value;

    async function setLikesValue() {
      const likesNode = document.getElementById("likes-number");
      const likes = await fetchPostLikesNumber(postId);
      likesNode.textContent = likes;
    }

    async function setIsLike() {
      const likeThumbNode = document.getElementById("like-thumb");
      const like = await fetchIsLike(postId);
      if (like) {
        likeThumbNode.className = "bi-hand-thumbs-up-fill";
      } else {
        likeThumbNode.className = "bi-hand-thumbs-up";
      }
    }

    async function like() {
      const data = await saveLike(postId);

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
