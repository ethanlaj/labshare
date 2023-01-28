import React from "react";
import CommentModel from "../../models/comment";
import Comment from "./Comment";

interface CommentsTableProps {
	comments: CommentModel[];
}

const CommentsTable = ({ comments }: CommentsTableProps) => {
	return (
		<table id="commentTable" className="table">
			<tbody>
				{comments &&
					comments.map((c) => (
						<Comment
							author_id={c.author_id}
							children={c.children}
							content={c.content}
							creationDate={c.creationDate}
							fullName={c.fullName}
							key={c.comment_id}
							profilepic={c.profilepic}
							username={c.username}
						></Comment>
					))}
			</tbody>
		</table>
	);
};

export default CommentsTable;
