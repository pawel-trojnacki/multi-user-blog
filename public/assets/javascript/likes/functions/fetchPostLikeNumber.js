export async function fetchPostLikesNumber(postId) {
  const response = await fetch(`/post-likes?id=${postId}`);
  const data = await response.json();
  return data.likes;
}
