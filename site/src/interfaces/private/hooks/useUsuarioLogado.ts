import { useState, useEffect } from 'react';
import { useVerifyAuth } from '@/services/auth/queries';

// Definindo a interface para o usuário logado
interface User {
    id: any;
    access_levels: Array<string>;
    age: string;
    biography: string;
    city: string;
    created_at: string;
    email: string;
    is_active: number;
    likes: string[];
    name: string;
    nickname: string;
    slug: string;
    social_networks: string[];
    state: string;
    updated_at: string;
}

const useUsuarioLogado = (): User | null => {
    // Definindo o estado para o usuário logado
    const [user, setUser] = useState<User | null>(null);

    // Buscando o token do localStorage
    const token = localStorage.getItem('akb_token');

    // Utilizando o hook personalizado para verificar dados
    const verifyAuthQuery = useVerifyAuth();

    useEffect(() => {
        // Verificando se o token não foi encontrado
        if (!token) {
            console.log('Token não encontrado');
        }

        // Verificando se a requisição foi bem sucedida
        if(verifyAuthQuery.isSuccess) {
            setUser(verifyAuthQuery.data.user);
        }

        // Verificando se houve erro na requisição
        if(verifyAuthQuery.isError) {
            console.log('Erro ao buscar usuário logado');
        }
    }, [token, verifyAuthQuery?.data?.user]);

    return user;
};

export default useUsuarioLogado;
