import React, { Fragment } from "react";
import CommentsTable from "./CommentsTable";
import Comment from "../../models/comment";

interface CommentsProps {
	comments: Comment[];
}

const Comments = ({ comments }: CommentsProps) => {
	return (
		<Fragment>
			<section id="comments">
				<div id="commentHeader">
					<h2>Comments</h2>

					<button
						id="newComment"
						className="btn btn-primary btn-sm"
						data-bs-toggle="modal"
						data-bs-target="#addComment"
					>
						Add Comment
					</button>
				</div>

				<CommentsTable comments={comments}></CommentsTable>
			</section>
		</Fragment>
	);
};

export default Comments;
