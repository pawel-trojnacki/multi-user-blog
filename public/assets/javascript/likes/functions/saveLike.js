export async function saveLike(postId) {
  const response = await fetch(`/post-like?id=${postId}`, {
    method: "POST",
    body: JSON.stringify({ id: postId }),
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  });

  return await response.json();
}
