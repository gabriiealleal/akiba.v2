import { useMutation, useQueryClient } from '@tanstack/react-query';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';

//Importando api
import { auth } from './api.ts';

export const useAuth = () => {
    const navigate = useNavigate();
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: auth,
        onSuccess: (data) => {
            navigate('/painel/dashboard');
            localStorage.setItem('akb_token', data.access_token);
        },
        onMutate: () => {
            queryClient.clear();
        },
        onError: (error: any) => {
            toast.error(error.response.data.message)
        }
    });
}