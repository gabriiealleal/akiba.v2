import { useQuery } from '@tanstack/react-query';
import { NotificationParams } from '@/services/notifications_team/interfaces.ts';
import { getNotificationsTeam } from './api.ts';

export const useNotificationsTeam = (queryParams: NotificationParams) => {
    return useQuery({
        queryKey: ['notificationsTeam'],
        queryFn: () => getNotificationsTeam(queryParams),
        enabled: !!queryParams,
        refetchOnWindowFocus: false,
        retry: false,
    })
}