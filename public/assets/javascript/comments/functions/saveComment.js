export async function saveComment(content, postId) {
  const response = await fetch("/api/post-comment", {
    method: "POST",
    body: JSON.stringify({ content, postId }),
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  });

  return await response.json();
}
