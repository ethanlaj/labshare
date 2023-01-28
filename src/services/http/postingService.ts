import axios from "axios";
import Post from "../../models/post";

class PostingService {
	http = axios.create({
		baseURL: "http://localhost/cs310/labshare-api/posting",
	});

	async getPost(post_id: number) {
		const response = await this.http.get<Post>("/post.php", {
			params: { post_id },
		});
		return response.data;
	}

	async getPosts() {
		const response = await this.http.get<Post[]>("/posts.php");
		return response.data;
	}

	async createPost(title: string, content: string, zip: number) {
		const response = await this.http.post<Post>("/post.php", {
			title,
			content,
			zip,
		});
		return response.data;
	}

	async editPost(
		post_id: number,
		title: string,
		content: string,
		zip: number
	) {
		const response = await this.http.put("/post.php", {
			post_id,
			title,
			content,
			zip,
		});
		return response.data;
	}

	async deletePost(post_id: number) {
		const response = await this.http.delete("/todos/", {
			params: { post_id },
		});
		return response.data;
	}
}

let service = new PostingService();
export default service;
