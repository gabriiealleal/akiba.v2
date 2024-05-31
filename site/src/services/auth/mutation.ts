import { useMutation, useQueryClient } from '@tanstack/react-query';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import { Auth } from './api.ts';

export const useAuth = () => {
    const queryClient = useQueryClient();
    const navigate = useNavigate();
    return useMutation({
        mutationFn: Auth,
        onSuccess: (data:any) => {
            toast.dismiss()
            navigate('/painel/dashboard');
            localStorage.setItem('akb_token', data.access_token);
        },
        onMutate: () => {
            toast.loading("Realizando login ...")
            queryClient.clear();
        },
        onError: (error: any) => {
            toast.dismiss()
            toast.error(error.response.data.message)
            console.error(error)
        }
    });
}