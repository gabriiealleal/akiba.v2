import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import icone from '/images/icone.webp';
import { useVerifyAuth } from '@/services/auth/queries';

interface PrivateRouterProps {
    View: React.ComponentType;
  }

const PrivateRouter: React.FC<PrivateRouterProps> = ({ View }) => {
    const navigate = useNavigate();
    const verifyAuthQuery = useVerifyAuth();

    useEffect(()=>{
        if (verifyAuthQuery.isError) {
            // Se ocorrer um erro durante a verificação, limpe o armazenamento e redirecione
            localStorage.removeItem('akb_token');
            navigate('/painel');
        }
    }, [verifyAuthQuery.isError])

    if (verifyAuthQuery.isLoading) {
        return (
            <div className="z-50 fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-azul-escuro">
                <img src={icone} alt="logomarca" className="w-12 animate-pulse" />
            </div>
        );    
    }

    if (verifyAuthQuery.isSuccess) {
        return <View />;
    }

    return (
        <div className="z-50 fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-azul-escuro">
            <img src={icone} alt="logomarca" className="w-12 animate-pulse" />
        </div>
    );
};

export default PrivateRouter;