import { useMutation, useQueryClient } from '@tanstack/react-query';
import { toast } from 'react-toastify';
import { Auth } from './api.ts';

export const useAuth = () => {
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: Auth,
        onSuccess: (data) => {
            window.location.href = '/painel/dashboard';
            localStorage.setItem('akb_token', data.access_token);
        },
        onMutate: () => {
            queryClient.clear();
        },
        onError: (error: any) => {
            toast.error(error.response.data.message)
            console.error(error)
        }
    });
}