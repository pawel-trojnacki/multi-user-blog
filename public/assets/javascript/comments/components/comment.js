import { wrapper } from "./wrapper";
import { content } from "./content";
import { info } from "./info";

export function comment(data, listElement) {
  const commentWrapper = wrapper();
  const commentInfo = info(
    data["author_id"],
    data["user_avatar"],
    data["user_name"],
    data["comment_date"]
  );
  const commentContent = content(data["comment_content"]);

  commentWrapper.appendChild(commentInfo);
  commentWrapper.appendChild(commentContent);
  listElement.prepend(commentWrapper);
}
