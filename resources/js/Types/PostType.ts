import type { UserType } from "@/UserType.ts";

export interface PostType {
  caption: string;
  created_at: string;
  id: string;
  user: UserType;
  likes: BigInteger;
  liked_by_user: boolean;
}
