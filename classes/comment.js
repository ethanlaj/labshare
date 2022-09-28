"use strict";

export class Comment {
	/**
	 * Matches the Comments table in the database
	 * @param {int} comment_id 
	 * @param {int} post_id 
	 * @param {int} author_id Matches user_id, this is the comment author.
	 * @param {timestamp} timestamp 
	 * @param {int} parent_id 
	 * @param {string} content 
	 * @param {int} reports 
	 * @param {boolean} inactive 
	 */

	constructor(comment_id, post_id, author_id,
		timestamp, parent_id, content,
		reports, inactive) {

		this.comment_id = comment_id;
		this.post_id = post_id;
		this.author_id = author_id;
		this.timestamp = timestamp;
		this.parent_id = parent_id;
		this.content = content;
		this.reports = reports;
		this.inactive = inactive;
	}
}