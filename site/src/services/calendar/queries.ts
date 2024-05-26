import { useQuery } from '@tanstack/react-query';
import { getCalendar } from './api.ts';

export const useCalendar = () => {
    return useQuery({
        queryKey: ['calendar'],
        queryFn: () => getCalendar(),
        retry: false,
    })
}