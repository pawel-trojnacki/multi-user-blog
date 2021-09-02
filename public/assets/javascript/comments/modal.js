export function commentsModal() {
    const commentsButton = document.getElementById("comments-button");

    if (commentsButton) {
      
      const closeButton = document.getElementById("comments-close-button");
      const modal = document.getElementById("comments-modal");
      const wrapper = document.getElementById("comments-wrapper");
    
      function toggleCommentsModalVisibility() {
        modal.classList.toggle("hidden");
      }
    
      function toggleCommentsWrapperTransform() {
        wrapper.classList.toggle("comments-wrapper-hidden");
      }
    
      commentsButton.addEventListener("click", function () {
        toggleCommentsModalVisibility();
        toggleCommentsWrapperTransform();
      });
    
      closeButton.addEventListener("click", function () {
        toggleCommentsModalVisibility();
        toggleCommentsWrapperTransform();
      });
    }
}


