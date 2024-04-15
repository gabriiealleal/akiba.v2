import { useQuery } from '@tanstack/react-query';
import { verifyAuth } from './api';

export const useVerifyAuth = (token: string) => {
    return useQuery({
        queryKey: ['verifyAuth', token],
        queryFn: () => verifyAuth(token),
        enabled: !!token,
    })
}
