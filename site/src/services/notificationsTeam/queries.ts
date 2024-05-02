import { useQuery } from '@tanstack/react-query';

//Importando api
import { getNotificationsTeam } from './api.ts';

//Importando interfaces
import { NotificationParams } from '@/services/notificationsTeam/interfaces.ts';

export const useNotificationsTeam = (queryParams: NotificationParams) => {
    return useQuery({
        queryKey: ['notificationsTeam'],
        queryFn: () => getNotificationsTeam(queryParams),
        enabled: !!queryParams,
        retry: false,
    })
}