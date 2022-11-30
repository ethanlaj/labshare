# LabShare

Labshare is a web application which allows scientists and science enthusiasts to get help with their projects.

## Posting API

The following request formats begin with `api/posting/`

#### Add Comment

Request Type: `POST`

Request Format: `addComment.php` with POST parameters of `post_id` and `content`. Optionally, include `parent_id` to add a reply.

Returned Data: None

Description: Adds a comment or a reply to the specified post as the currently logged in user.

#### Apply

Request Type: `POST`

Request Format: `apply.php` with POST parameter `post_id`.

Returned Data: None

Description: Applies to the specified post as the currently logged in user.

#### Create Post

Request Type: `POST`

Request Format: `createPost.php` with POST parameters of `title` and `content`. Optionally, include `zip` to include the post location.

Returned Data: None

Description: Creates a new post as the currently logged in user.

#### Delete Comment

Request Type: `POST`

Request Format: `deleteComment.php` with POST parameter `comment_id`.

Returned Data: None

Description: Deletes a comment and its replies if it was created by the currently logged in user.

#### Delete Post

Request Type: `POST`

Request Format: `deletePost.php` with POST parameter `post_id`.

Returned Data: None

Description: Deletes a post if it was created by the currently logged in user.

#### Edit Comment

Request Type: `POST`

Request Format: `editComment.php` with POST parameters of `comment_id` and `content`.

Returned Data: None

Description: Edits a comment if it was created by the currently logged in user.

#### Edit Post

Request Type: `POST`

Request Format: `editPost.php` with POST parameters of `post_id`, `title` and `content`. Optionally, include `zip` to include the post location.

Returned Data: None

Description: Edits a post if it was created by the currently logged in user.

#### Get All Posts

Request Type: `GET`

Request Format: `getAllPosts.php?type=saved&search=Science`

Valid Types:

-   `your` - Returns posts created by the currently logged in user
-   `saved` - Returns the currently logged in user's saved posts

Returned Data: JSON Format

Description: The returned JSON data returns the `post_id`, `creationDate`, `title`, `content`, `username`, `fullName`,`profilepic`, `author_id`, `zip`, `lat`, and `lon` of all of the posts in the database, ordered by creation date descending.

#### Report

Request Type: `POST`

Request Format: `report.php` with POST parameters of `id` and `type`.

Valid Types:

-   `1` - Post
-   `2` - Comment

Returned Data: None

Description: Reports the post or comment with the specified id.

#### Save

Request Type: `POST`

Request Format: `save.php` with POST parameter `post_id`.

Returned Data: None

Description: Saves the post as the currently logged in user.

#### Unsave

Request Type: `POST`

Request Format: `unsave.php` with POST parameter `post_id`.

Returned Data: None

Description: Unsaves the post as the currently logged in user.
