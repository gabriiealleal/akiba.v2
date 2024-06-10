import { useQuery } from '@tanstack/react-query';
import { NotificationTypes } from '@/services/notifications_team/types.ts';
import { getNotificationsTeam } from './api.ts';

export const useNotificationsTeam = (queryParams: NotificationTypes) => {
    return useQuery({
        queryKey: ['notificationsTeam'],
        queryFn: () => getNotificationsTeam(queryParams),
        enabled: !!queryParams,
        refetchOnWindowFocus: false,
        retry: false,
    })
}