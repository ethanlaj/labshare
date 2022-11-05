<?PHP
session_start();

$post = null;

if (isset($_GET["id"])) {
	require_once("../database/postFunctions.php");

	$post = getPost($_GET["id"], true);
}

$logged_in_user = isset($_SESSION["user"])
	? $_SESSION["user"] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?PHP echo $post ? $post->title : "Invalid Post" ?></title>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />

	<!--Montserrat Font-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />

	<link rel="stylesheet" href="./css/post.css" />

	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<!--Global CSS and JS-->
	<link rel="stylesheet" href="../global/global.css" />
	<script src="../global/global.js"></script>

	<script src="./js/post.js"></script>

	<!--favicon-->
	<link rel="icon" type="image/x-icon" href="../global/LabShareLogo.png" />
</head>

<body>
	<div id="navbar"></div>

	<?PHP if ($post) { ?>
		<main id="post">
			<div id="postHeader">
				<img src="../global/etown-BlueJay.png" alt="<?PHP echo $post->username ?>">

				<div id="nextToProfilePic">
					<a <?PHP echo "href=\"../profiles/yourProfile.html?id={$post->author_id}\"" ?>>
						<?PHP echo $post->username ?>
					</a>
					<p><?PHP echo $post->creationDate ?></p>

					<div id="postTitleWithDropdown">
						<h1 id="postTitle">
							<?PHP echo $post->title ?>
						</h1>
						<?PHP if ($logged_in_user && $logged_in_user == $post->author_id) { ?>
							<!--This Dropdown should only be visible to the post owner-->
							<div class="dropdown-center dropend">
								<button class="commentButton btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									...
								</button>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" href="./editPost.php?id=<?PHP echo $post->post_id ?>">Edit</a>
									</li>
									<li>
										<button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deletePost">
											Delete
										</button>
									</li>
								</ul>
							</div>
						<?PHP } ?>
					</div>
					<?PHP if ($logged_in_user && $logged_in_user != $post->author_id) { ?>
						<!-- Should only be visible for non-authors -->
						<div id="actionButtons">
							<button id="savePostBtn" class="btn btn-sm btn-outline-primary">
								<?PHP echo $post->hasSaved ? "Unsave" : "Save" ?>
							</button>
							<button id="applyToPostBtn" <?PHP if ($post->hasApplied) echo "disabled" ?> class="btn btn-sm btn-outline-success">
								<?PHP echo $post->hasApplied ? "Applied" : "Apply" ?>
							</button>

							<?PHP
							if ($post->hasReported == false) {
							?>
								<button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#reportPost">
									Report
								</button>
						</div>
					<?PHP
							}
					?>
				<?PHP } ?>
				</div>
			</div>
			<p id="postText"><?PHP echo $post->content ?></p>
		</main>

		<hr />

		<section id="comments">
			<div id="commentHeader">
				<h2>Comments</h2>

				<?PHP
				if ($logged_in_user) {
				?>
					<button id="newComment" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addComment">
						Add Comment
					</button>
				<?PHP
				}
				?>
			</div>

			<?PHP
			if ($logged_in_user && count($post->comments) > 0) {
			?>
				<!--For logged in users only-->
				<table id="commentTable" class="table">
					<?PHP
					foreach ($post->comments as $comment) {
						if ($comment->parent_id)
							continue;
					?>
						<tr id=<?PHP echo "comment" . $comment->comment_id ?> class="comment">
							<td>
								<div class="commentDate"><?PHP echo $comment->creationDate ?></div>
								<div class="user">
									<img src="../global/blank.jpg" alt="<?PHP echo $comment->username ?>" />
									<a href="<?PHP echo "../profiles/yourProfile.php?id=" . $comment->author_id ?>">
										<?PHP echo $comment->username ?>
									</a>
								</div>
							</td>
							<td>
								<div class="commentContent"><?PHP echo $comment->content ?></div>

								<textarea hidden class="replyBox form-control" maxlength="500"></textarea>
								<div class="replyActionButtons">
									<button hidden class="cancelReply btn btn-sm btn-secondary">
										Cancel
									</button>
									<button class="replyButton btn btn-sm btn-secondary">
										Reply
									</button>
								</div>
							</td>
							<td>
								<?PHP if (
									$logged_in_user == $comment->author_id
									|| !reportExists($comment->comment_id, 2)
								) { ?>
									<div class="dropdown-center">
										<button class="commentButton btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											...
										</button>
										<ul class="dropdown-menu">
											<?PHP if ($logged_in_user == $comment->author_id) { ?>
												<li><a class="dropdown-item edit">Edit</a></li>
												<li>
													<a class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#deleteComment">Delete</a>
												</li>
											<?PHP } else if (!reportExists($comment->comment_id, 2)) { ?>
												<li>
													<button class="dropdown-item report" data-bs-toggle="modal" data-bs-target="#reportComment">
														Report
													</button>
												</li>
											<?PHP } ?>
										</ul>
									</div>
								<?PHP } ?>
							</td>
						</tr>
						<?PHP
						// For loop for replies
						if (count($comment->children) > 0)
							for ($i = 1; $i <= count($comment->children); $i++) {
								$child = $comment->children[$i - 1];
						?>
							<tr id="<?PHP echo "reply{$i}comment{$child->comment_id}" ?>" class="comment reply">
								<td>
									<div class="commentDate"><?PHP echo $child->creationDate ?></div>
									<div class="user">
										<img src="../global/blank.jpg" alt="<?PHP echo $child->username ?>" />
										<a href="<?PHP echo "../profiles/yourProfile.php?id=" . $child->author_id ?>">
											<?PHP echo $child->username ?>
										</a>
									</div>
								</td>
								<td>
									<div><i>Replying to <?PHP echo $comment->username ?></i></div>
									<div class="replyText commentContent">
										<?PHP echo $child->content ?>
									</div>
								</td>
								<td>
									<?PHP if (
										$logged_in_user == $child->author_id
										|| !reportExists($child->comment_id, 2)
									) { ?>
										<div class="dropdown-center">
											<button class="commentButton btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
												...
											</button>
											<ul class="dropdown-menu">
												<?PHP if ($logged_in_user == $child->author_id) { ?>
													<li><a class="dropdown-item edit">Edit</a></li>
													<li>
														<a class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#deleteComment">Delete</a>
													</li>
												<?PHP } else if (!reportExists($child->comment_id, 2)) { ?>
													<li>
														<button class="dropdown-item report" data-bs-toggle="modal" data-bs-target="#reportComment">
															Report
														</button>
													</li>
												<?PHP } ?>
											</ul>
										</div>
									<?PHP } ?>
								</td>
							</tr>

					<?PHP
							}
					}
					?>
				</table>
			<?PHP
			} else if (!$logged_in_user) {
			?>
				<p>You must be logged in to view comments</p>
			<?PHP
			} else {
			?>
				<p>Be the first to comment!</p>
			<?PHP
			}
			?>
		</section>

		<footer id="footer"></footer>

	<?PHP } else { ?>
		<p>This post has been deleted or does not exist.</p>
	<?PHP } ?>


	<!-- This is where all the modals will be placed -->
	<div id="modals">
		<!-- Poster Dropdown-->
		<!--Delete Post-->
		<div class="modal fade" id="deletePost" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Delete Post</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Are you sure you want to delete this post?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="deletePostBtn" type="button" class="btn btn-danger">
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Report Post -->
		<div class="modal fade" id="reportPost" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Report Post</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Are you sure you want to report this post?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="reportPostBtn" type="button" class="btn btn-danger">
							Report
						</button>
					</div>
				</div>
			</div>
		</div>

		<!--Comment Actions-->
		<!-- Report Comment -->
		<div class="modal fade" id="reportComment" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Report Comment</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Are you sure you want to report this comment?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="reportCommentBtn" type="button" class="btn btn-danger">
							Report
						</button>
					</div>
				</div>
			</div>
		</div>

		<!--Add Comment-->
		<div class="modal fade" id="addComment" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Comment</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form>
							<label class="form-label">Comment</label>
							<textarea id="commentAddTextForm" class="form-control" rows="5"></textarea>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="addCommentBtn" type="button" class="btn btn-success">
							Comment
						</button>
					</div>
				</div>
			</div>
		</div>

		<!--Edit Comment-->
		<div class="modal fade" id="editComment" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Comment</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="editForm">
							<label class="form-label">Comment</label>
							<textarea id="commentEditTextForm" class="form-control"></textarea>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="editCommentBtn" type="button" class="btn btn-success">
							Save
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Delete Comment -->
		<div class="modal fade" id="deleteComment" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Delete Comment</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Are you sure you want to delete this comment?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							Cancel
						</button>
						<button id="deleteCommentBtn" type="button" class="btn btn-danger">
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Comment Deletion Successful-->
		<div class="modal fade" id="commentDeleted" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Comment Deleted</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Successfully deleted comment
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">
							Close
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- General Message -->
		<div class="modal fade" id="generalMessage" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">
							Close
						</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>

</html>