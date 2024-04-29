import React, { useEffect } from 'react';

// Importando o serviço de verificação de autenticação
import { useVerifyAuth } from '@/services/auth/queries';

interface PrivateRouterProps {
    View: React.ComponentType;
}

const PrivateRouter: React.FC<PrivateRouterProps> = ({ View }) => {
    const token = localStorage.getItem('akb_token');

    // Utilizando o hook personalizado para verificação de autenticação
    const verifyAuthQuery = useVerifyAuth();

    // Efeito colateral para lidar com redirecionamento com base no status de autenticação
    useEffect(() => {
        if (!token) {
            // Se nenhum token for encontrado, navegue para o painel de login
            window.location.href = '/painel';
        } else if (verifyAuthQuery.isError) {
            // Se ocorrer um erro durante a verificação, limpe o armazenamento e redirecione
            localStorage.removeItem('akb_token');
            localStorage.removeItem('akb_user');
            window.location.href = '/painel';
        }
    }, [token, verifyAuthQuery.isError]);

    // Renderiza o componente View apenas se a autenticação for bem-sucedida
    if (verifyAuthQuery.isSuccess) {
        return <View />;
    }

    // Opcional: Renderiza null ou um spinner de carregamento enquanto verifica a autenticação
    return null; // ou retorne <Spinner />; se você tiver um componente de carregamento
};

export default PrivateRouter;
