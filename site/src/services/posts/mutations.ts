import { useMutation, useQueryClient } from '@tanstack/react-query';
import { PostTypes } from '@/services/posts/types.ts';
import { updatePost } from '@/services/posts/api.ts';

export const useUpdatePost = (id: number, onSuccessCallback:Function) => {
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: (data: PostTypes) => updatePost(id, data),
        onSuccess: () => {
            queryClient.invalidateQueries({queryKey: ['tasks']});
            onSuccessCallback();
        },
        onMutate: () => {
            console.log("Atualizando post...");
            queryClient.clear();
        },
        onError: (error: any) => {
            console.error('Ocorreu um erro ao atualizar o post...', error);
        },
        onSettled: () => {
            console.log("Post atualizado...");
        }
    });
}