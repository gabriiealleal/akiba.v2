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
            navigate('/painel/dashboard');
            toast.dismiss();
            toast.success('Login realizado. Seja bem vindo!');
            localStorage.setItem('akb_token', data.access_token);
        },
        onMutate: () => {
            toast.loading("Realizando login ...")
            queryClient.clear();
        },
        onError: (error: any) => {
            toast.error(error.response.data.message)
            console.error(error)
        }
    });
}