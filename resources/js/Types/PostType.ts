import type { UserType } from '@/UserType'

export interface PostType {
  caption: string
  createdAt: string
  id: string
  user: UserType
  likes: BigInteger
  likedByUser: boolean
  image: string
}
