import { useEffect } from 'react';
import icone from '/images/icone.webp';

// Importando o serviço de verificação de autenticação
import { useVerifyAuth } from '@/services/auth/queries';

interface PrivateRouterProps {
    View: React.ComponentType;
}

const PrivateRouter: React.FC<PrivateRouterProps> = ({ View }) => {
    const verifyAuthQuery = useVerifyAuth();

    useEffect(()=>{
        if (verifyAuthQuery.isError) {
            // Se ocorrer um erro durante a verificação, limpe o armazenamento e redirecione
            localStorage.removeItem('akb_token');
            window.location.href = '/painel';
        }
    }, [verifyAuthQuery.isError])

    // Renderiza o componente View apenas se a autenticação for bem-sucedida
    if (verifyAuthQuery.isSuccess) {
        return <View />;
    }

    return (
        <div className="z-50 fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-azul-escuro">
            <img src={icone} alt="logomarca" className="w-12 animate-pulse" />
        </div>
    );};

export default PrivateRouter;
