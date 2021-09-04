import { comment } from "./comment";

export function list(comments, listElement) {
  comments.reverse().forEach((data) => {
    comment(data, listElement);
  });
}
