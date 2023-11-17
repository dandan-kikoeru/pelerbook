import type { UserType } from '@/UserType'

export interface PostType {
  caption: string
  createdAt: string
  id: string
  likes: BigInteger
  likedByUser: boolean
  image: string
  user: UserType
}
