import React, { Fragment } from "react";
import CommentModel from "../../models/comment";

interface CommentProps {
	fullName: string;
	username: string;
	author_id: number;
	profilepic: string;
	content: string;
	children: CommentModel[];
	creationDate: string;
	parent_id?: number;
}
const Comment = (props: CommentProps) => {
	const isReply = props.parent_id != null;

	return (
		<Fragment>
			<tr className="comment">
				<td>
					<div className="flexRowContainer">
						<img
							className="commentProfilePic"
							src={props.profilepic}
							alt={props.username}
						/>
						<div className="nextToCommentProfilePic">
							<div className="commentUnameDate">
								<a
									className="username"
									href={
										"../profiles/profile.php?id=" +
										props.author_id
									}
								>
									{props.fullName}
								</a>
								<div className="commentDate">
									{props.creationDate}
								</div>
							</div>
						</div>
					</div>
					<div className="contentAndReplyBox">
						{/* <?PHP echo str_replace("\n", "<br />", $comment->content) ?> */}
						<div className="commentContent">{props.content}</div>

						<form className="replyForm">
							<textarea
								hidden
								className="replyBox form-control"
							></textarea>
							<div className="replyActionButtons">
								<button
									type="button"
									className="replyButton btn btn-sm btn-secondary"
								>
									Reply
								</button>
								<button
									hidden
									type="button"
									className="cancelReply btn btn-sm btn-secondary"
								>
									Cancel
								</button>
							</div>
						</form>
					</div>
				</td>
				<td>
					<div className="dropdown-center">
						<button
							className="commentButton btn dropdown-toggle"
							type="button"
							data-bs-toggle="dropdown"
							aria-expanded="false"
						>
							...
						</button>
						<ul className="dropdown-menu">
							<li>
								<a className="dropdown-item edit">Edit</a>
							</li>
							<li>
								<a
									className="dropdown-item delete"
									data-bs-toggle="modal"
									data-bs-target="#deleteComment"
								>
									Delete
								</a>
							</li>
							<li>
								<button
									className="dropdown-item report"
									data-bs-toggle="modal"
									data-bs-target="#reportComment"
								>
									Report
								</button>
							</li>
						</ul>
					</div>
				</td>
			</tr>
			{props.children.map((r) => (
				<Comment
					key={r.comment_id}
					fullName={r.fullName}
					username={r.username}
					author_id={r.author_id}
					profilepic={r.profilepic}
					children={r.children}
					content={r.content}
					creationDate={r.creationDate}
					parent_id={r.parent_id}
				></Comment>
			))}
		</Fragment>
	);
};

export default Comment;
