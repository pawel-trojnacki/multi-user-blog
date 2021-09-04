export async function fetchIsLike(postId) {
  const response = await fetch(`/post-like?id=${postId}`);
  const data = await response.json();
  return data.like;
}
