import type { PostType } from '@/PostType'

export interface PostsType {
  data: PostType[]
  links: {
    first: string
    last: string
    prev: string
    next: string
  }
}
