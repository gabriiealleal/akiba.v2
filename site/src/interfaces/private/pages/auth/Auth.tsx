import { toast } from 'react-toastify';
import { useForm } from 'react-hook-form';

//Importando assets
import logomarca from '/images/logomarca.webp';

//Importando icones
import { IoIosHelpCircleOutline } from "react-icons/io";

//Importando hooks personalizados
import usePageName from "@/hooks/usePageName.tsx";

//Importando queries e mutations do react-query
import { useAuth } from '@/services/auth/mutation.ts';
import { useVerifyAuth } from '@/services/auth/queries';

const Auth = () => {
    //Definindo useForm
    const { register, handleSubmit } = useForm();

    //Definindo o nome da página
    usePageName('Realize o Login');

    //Requisição de autenticação
    const {mutate: Auth } = useAuth();

    // Verificação de autenticação
    const token = localStorage.getItem('akb_token');
    if (token) {
        const { isSuccess, isError } = useVerifyAuth();
        if (isError) {
            toast.error('Sessão expirada, realize o login novamente');
        }
        if (isSuccess) {
            window.location.href = '/painel/dashboard';
        }
    }

    //Função para submeter o formulário
    const onSubmit = (data: any) => {
        Auth(data);
    }

    return (
        <section className="bg-login bg-cover h-screen flex flex-wrap justify-center items-center">
            <div className="w-52">
                <div className="w-full flex justify-center">
                    <img className="w-32" src={logomarca} alt="Logomarca" />
                </div>
                <strong className='mt-3 block w-full text-center font-averta text-aurora text-sm'>Realize o login para acessar</strong>
                <form className="mt-2" onSubmit={handleSubmit(onSubmit)}>
                    <input {...register('login', {required: true})} type="text" id="login" className="w-full h-14 p-2 border rounded-t-lg font-averta text-sm outline-none" placeholder="Login" aria-label="login" />
                    <input {...register('password', { required: true })} type="password" id="password" className="w-full h-14 p-2 border rounded-b-lg font-averta text-sm outline-none" placeholder="Senha" aria-label="senha" />
                    <button type="submit" className="w-full h-14 bg-azul-claro text-white font-averta font-extrabold italic uppercase text-sm rounded-lg mt-2">Entrar</button>
                </form>
                <div className="flex justify-center mt-4">
                    <button className="flex items-center gap-1 text-aurora text-sm font-averta " aria-label="ajuda" onClick={()=>{toast.info('Procure a administração da Akiba')}}><IoIosHelpCircleOutline/>Ajuda</button>
                </div>
            </div>
        </section>
    );
}

export default Auth;