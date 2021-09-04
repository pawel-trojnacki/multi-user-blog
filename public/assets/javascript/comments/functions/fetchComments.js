export async function fetchComments(id) {
  const response = await fetch(`/api/post-comments?id=${id}`);
  const data = await response.json();
  return data;
}
