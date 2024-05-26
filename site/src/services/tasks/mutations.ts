import { useMutation, useQueryClient } from '@tanstack/react-query';
import { getTasksTypes } from '@/services/tasks/interfaces.ts';
import { updateTaks } from './api.ts';

export const useUpdateTasks = (id:getTasksTypes, onSuccessCallback:Function) => {
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: (data: any) => updateTaks(id, data),
        onSuccess: () => {
            queryClient.invalidateQueries({queryKey: ['tasks']});
            onSuccessCallback();
        },
        onMutate: () => {
            console.log("Atualizando tarefa...");
            queryClient.clear();
        },
        onError: (error: any) => {
            console.error(error);
        },
        onSettled: () => {
            console.log("Tarefa atualizada...");
        }
    });
}