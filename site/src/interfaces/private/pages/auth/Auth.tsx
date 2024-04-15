import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';

//Importando assets
import logomarca from '/images/logomarca.webp';

//Importando icones
import { IoIosHelpCircleOutline } from "react-icons/io";

//Importando hooks
import usePageName from "@/hooks/usePageName.tsx";

//Importando serviços
import { useAuth } from '@/interfaces/private/services/auth/mutation.ts';
import { useVerifyAuth } from '@/interfaces/private/services/auth/queries';

const Auth = () => {
    //Definindo o nome da página
    usePageName('Realize o Login');

    //Definindo navigate
    const navigate = useNavigate();

    // Verificação de autenticação
    if(localStorage.getItem('akb_token')){
        const verifyAuthQuery = useVerifyAuth(localStorage.getItem('akb_token') ?? '');
        if(verifyAuthQuery.isError){
            toast.error('Sessão expirada, realize o login novamente')
        }
        if(verifyAuthQuery.isSuccess){
            navigate('/painel/dashboard');
        }
    }

    // Requisição de autenticação
    const handleAuth = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const login = (event.currentTarget.elements.namedItem('login') as HTMLInputElement).value;
        const password = (event.currentTarget.elements.namedItem('password') as HTMLInputElement).value;
        const authMutation = useAuth();
        authMutation.mutate({login: login, password: password});
    }

    return (
        <section className="bg-login bg-cover h-screen flex flex-wrap justify-center items-center">
            <div className="w-52">
                <div className="w-full flex justify-center">
                    <img className="w-32" src={logomarca} alt="Logomarca" />
                </div>
                <strong className='mt-3 block w-full text-center font-light text-aurora text-sm'>Realize o login para acessar</strong>
                <form className="mt-2" onSubmit={handleAuth}>
                    <input type="text" id="login" name="login" className="w-full h-14 p-2 border rounded-t-lg font-light text-sm outline-none" placeholder="Login" aria-label="login" />
                    <input type="password" id="password" name="password" className="w-full h-14 p-2 border rounded-b-lg font-light text-sm outline-none" placeholder="Senha" aria-label="senha" />
                    <button type="submit" className="w-full h-12 bg-azul-claro text-white font-light text-sm rounded-lg mt-2" aria-label="entrar">Entrar</button>
                </form>
                <div className="flex justify-center mt-4">
                    <button className="flex items-center gap-1 text-aurora text-sm" aria-label="ajuda" onClick={()=>{toast.info('Procure a administração da Akiba')}}><IoIosHelpCircleOutline/>Ajuda</button>
                </div>
            </div>
        </section>
    );
}

export default Auth;