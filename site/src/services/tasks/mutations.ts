import { useMutation, useQueryClient } from '@tanstack/react-query';
import { tasksTypes } from '@/services/tasks/types.ts';
import { updateTaks } from './api.ts';

export const useUpdateTasks = (id:tasksTypes, onSuccessCallback:Function) => {
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: (data: tasksTypes) => updateTaks(id, data),
        onSuccess: () => {
            queryClient.invalidateQueries({queryKey: ['tasks']});
            onSuccessCallback();
        },
        onMutate: () => {
            console.log("Atualizando tarefa...");
            queryClient.clear();
        },
        onError: (error: any) => {
            console.error('Ocorreu um erro ao atualizar a tarefa...', error);
        },
        onSettled: () => {
            console.log("Tarefa atualizada...");
        }
    });
}