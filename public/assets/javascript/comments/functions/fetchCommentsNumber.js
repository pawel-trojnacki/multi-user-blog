export async function fetchCommentsNumber(id) {
  const response = await fetch(`/api/post-comments-number?id=${id}`);
  const data = await response.json();
  const commentsNumber = data["comments_number"] || 0;

  return commentsNumber;
}
