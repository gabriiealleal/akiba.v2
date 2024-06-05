import { useQuery } from '@tanstack/react-query';
import { getPosts, getPost } from './api.ts';

export const usePosts = () => {
    return useQuery({
        queryKey: ['posts'],
        queryFn: () => getPosts(),
        retry: false,
        refetchOnWindowFocus: false,
    })
}

export const usePost = (slug: string) => {
    return useQuery({
        queryKey: ['post', slug],
        queryFn: () => getPost(slug), 
        retry: false,
        refetchOnWindowFocus: false,
    })
}