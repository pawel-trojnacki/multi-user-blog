import { comment } from "./components/comment";
import { list } from "./components/list";
import { fetchComments } from "./functions/fetchComments";
import { fetchCommentsNumber } from "./functions/fetchCommentsNumber";
import { saveComment } from "./functions/saveComment";

export async function comments() {
  const commentsButton = document.getElementById("comments-button");

  if (commentsButton) {
    const postIdInput = document.getElementById("post-id");
    const postId = postIdInput.value;

    const closeButton = document.getElementById("comments-close-button");
    const modal = document.getElementById("comments-modal");
    const wrapper = document.getElementById("comments-wrapper");
    const commentList = document.getElementById("comments");
    const commentsNumberElement = document.getElementById("comments-number");

    const commentForm = document.getElementById("comment-form");
    const commentField = document.getElementById("comment-field");
    const invalidFeedback = document.getElementById("comment-invalid");

    let fetched = false;

    async function setCommentsNumber() {
      const commentsNumber = await fetchCommentsNumber(postId);
      commentsNumberElement.textContent = commentsNumber;
    }

    function toggleCommentsModalVisibility() {
      modal.classList.toggle("hidden");
    }

    function toggleCommentsWrapperTransform() {
      wrapper.classList.toggle("comments-wrapper-hidden");
    }

    setCommentsNumber();

    commentsButton.addEventListener("click", async function () {
      toggleCommentsModalVisibility();
      toggleCommentsWrapperTransform();
      if (!fetched) {
        const comments = await fetchComments(postId);
        list(comments, commentList);
      }
      fetched = true;
    });

    closeButton.addEventListener("click", function () {
      toggleCommentsModalVisibility();
      toggleCommentsWrapperTransform();
    });

    commentForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const content = commentField.value;
      const response = await saveComment(content, postId);

      if (response.notAuthenticated) {
        alert("You have to be authenticated");
      }

      if (response.errors?.content) {
        invalidFeedback.textContent = response.errors.content[0];
        commentField.classList.add("is-invalid");
      }

      if (response.success && response.comment) {
        invalidFeedback.textContent = "";
        commentField.value = "";
        if (commentField.classList.contains("is-invalid")) {
          commentField.classList.remove("is-invalid");
        }

        comment(response.comment, commentList);
        setCommentsNumber();
      }
    });
  }
}
