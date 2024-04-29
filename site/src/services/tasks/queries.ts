import { useQuery } from '@tanstack/react-query';

//Importando api
import { getTasks } from './api.ts';

export const useTasks = () => {
    return useQuery({
        queryKey: ['tasks'],
        queryFn: () => getTasks(),
    })
}