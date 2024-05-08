import { useQuery } from '@tanstack/react-query';
import { getTasksTypes } from './interfaces.ts';
import { getTasks } from './api.ts';


export const useTasks = (queryParams: getTasksTypes) => {
    return useQuery({
        queryKey: ['tasks'],
        queryFn: () => getTasks(queryParams),
        enabled: !!queryParams.user,
        retry: false,
    })
}