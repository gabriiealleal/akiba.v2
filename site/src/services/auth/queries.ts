import { useQuery } from '@tanstack/react-query';
import { verifyAuth } from './api';

export const useVerifyAuth = () => {
    return useQuery({
        queryKey: ['verifyAuth'],
        queryFn: () => verifyAuth(),
    })
}
