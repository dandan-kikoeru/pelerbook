import type { UserType } from "@/UserType.ts";

export interface PostType {
  caption: string;
  createdAt: string;
  id: string;
  user: UserType;
  likes: BigInteger;
  likedByUser: boolean;
  image: string;
}
