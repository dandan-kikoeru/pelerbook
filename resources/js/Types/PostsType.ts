import type { PostType } from "@/PostType.ts";

export interface PostsType {
  data: PostType[];
  meta: {
  path: string;
    next_cursor: string | null;
  };
}
