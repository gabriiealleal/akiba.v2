import { useQuery } from '@tanstack/react-query';
import { getPosts } from './api.ts';

export const usePosts = () => {
    return useQuery({
        queryKey: ['posts'],
        queryFn: () => getPosts(),
        retry: false,
        refetchOnWindowFocus: false,
    })
}