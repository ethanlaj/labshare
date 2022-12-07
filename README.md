# LabShare

Labshare is a web application which allows scientists and science enthusiasts to get help with their projects.

## Global API

The following request formats begin with `api/global/`

### Update Session

Request Type: `POST`

Request Format: `updateSession.php` with optional POST parameter `timezone`.

Returned Data: JSON Format

Description: If timezone is provided, it updates the user's timezone session data. Returns json data of whether the user is currently logged in and if the current page needs to be reloaded.

---

## Notifications API

The following request formats begin with `api/notifications/`

### Accept

Request Type: `POST`

Request Format: `accept.php` with POST parameter `id` (notification id).

Returned Data: None

Description: If notification is a new application, it accepts the applicant if the currently logged in user owns the notification provided.

### Decline

Request Type: `POST`

Request Format: `decline.php` with POST parameter `id` (notification id).

Returned Data: None

Description: If notification is a new application, it declines the applicant if the currently logged in user owns the notification provided.

### Dismiss

Request Type: `POST`

Request Format: `dismiss.php` with POST parameter `id` (notification id).

Returned Data: None

Description: Dismisses a notification if the currently logged in user owns the notification provided.

### Get Notifications

Request Type: `GET`

Request Format: `getNotifications.php`

Returned Data: JSON Format

Description: The returned JSON data returns the `notification_id`, `notification_date`, `type`, `post_id`, `count`, `title`, `poster_id`, `poster`, `posterEmail`, `posterPhone`, `applicant_id`, `applicant`, `applicantEmail`, `applicantPhone` of all of the active notifications in the database for the currently logged in user, ordered by notification date descending.

---

## Posting API

The following request formats begin with `api/posting/`

### Add Comment

Request Type: `POST`

Request Format: `addComment.php` with POST parameters of `post_id` and `content`. Optionally, include `parent_id` to add a reply.

Returned Data: None

Description: Adds a comment or a reply to the specified post as the currently logged in user.

### Apply

Request Type: `POST`

Request Format: `apply.php` with POST parameter `post_id`.

Returned Data: None

Description: Applies to the specified post as the currently logged in user.

### Create Post

Request Type: `POST`

Request Format: `createPost.php` with POST parameters of `title` and `content`. Optionally, include `zip` to include the post location.

Returned Data: None

Description: Creates a new post as the currently logged in user.

### Delete Comment

Request Type: `POST`

Request Format: `deleteComment.php` with POST parameter `comment_id`.

Returned Data: None

Description: Deletes a comment and its replies if it was created by the currently logged in user.

### Delete Post

Request Type: `POST`

Request Format: `deletePost.php` with POST parameter `post_id`.

Returned Data: None

Description: Deletes a post if it was created by the currently logged in user.

### Edit Comment

Request Type: `POST`

Request Format: `editComment.php` with POST parameters of `comment_id` and `content`.

Returned Data: None

Description: Edits a comment if it was created by the currently logged in user.

### Edit Post

Request Type: `POST`

Request Format: `editPost.php` with POST parameters of `post_id`, `title` and `content`. Optionally, include `zip` to include the post location.

Returned Data: None

Description: Edits a post if it was created by the currently logged in user.

### Get All Posts

Request Type: `GET`

Request Format: `getAllPosts.php?type=saved&search=Science`

Valid Types:

-   `your` - Returns posts created by the currently logged in user
-   `saved` - Returns the currently logged in user's saved posts

Returned Data: JSON Format

Description: The returned JSON data returns the `post_id`, `creationDate`, `title`, `content`, `username`, `fullName`,`profilepic`, `author_id`, `zip`, `lat`, and `lon` of all of the matched active posts in the database, ordered by creation date descending.

### Report

Request Type: `POST`

Request Format: `report.php` with POST parameters of `id` and `type`.

Valid Types:

-   `1` - Post
-   `2` - Comment

Returned Data: None

Description: Reports the post or comment with the specified id.

### Save

Request Type: `POST`

Request Format: `save.php` with POST parameter `post_id`.

Returned Data: None

Description: Saves the post as the currently logged in user.

### Unsave

Request Type: `POST`

Request Format: `unsave.php` with POST parameter `post_id`.

Returned Data: None

Description: Unsaves the post as the currently logged in user.

---

## Profiles API

The following request formats begin with `api/profiles/`

### Search

Request Type: `GET`

Request Format: `search.php?search=bill nye`

Returned Data: JSON Format

Description: The returned JSON data returns the `user_id`, `profilepic`, `username`, `firstName`, and `lastName` of the matched active user(s).
## Account API

The following request formats begin with `api/account/`

### Login

Request Type: `POST`

Request Format: login.php with POST parameters `username` and `password` that are retrieved from login form using a formData object

Returned Data: JSON Format

Description: The returned JSON data returns the true or false status of the associative array item loginSuccess. loginSuccess is returned true if the username and password given match a user in the database.

### Register

Request Type: `POST`

Request Format: register.php with POST parameters `firstName`, `lastName`, `email`, `userName`, `password`, `password2`, `phone`, and `birthday` that are retrieved from the register form using a formData object

Returned Data: JSON Format

Description: The returned JSON data returns the associate array which contains the boolean values creation_successful and username_taken. If the username given by the user is already an existing user, username_taken will return true. If the user is successfully added to the database, creation_successful will return true. Creation successful must return true and username_taken must return false in order for the user to be succesfully registered. 