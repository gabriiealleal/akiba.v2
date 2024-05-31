import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import { useForm } from 'react-hook-form';
import logomarca from '/images/logomarca.webp';
import { IoIosHelpCircleOutline } from "react-icons/io";
import usePageName from "@/hooks/usePageName.tsx";
import { useAuth } from '@/services/auth/mutation.ts';

const Auth = () => {
    const navigate = useNavigate();
    const pageName = usePageName;
    const { register, handleSubmit } = useForm();

    const { mutate: Auth } = useAuth();
    const onSubmit = (data: any) => {
        Auth(data);
    }

    const token = localStorage.getItem('akb_token');
    if(token){
        navigate('/painel/dashboard');
    }
    
    pageName('Realize o login');
    return (
        <section className="bg-login bg-cover h-screen flex flex-wrap justify-center items-center">
            <div className="w-52">
                <div className="w-full flex justify-center">
                    <img className="w-32" src={logomarca} alt="Logomarca" />
                </div>
                <strong className='mt-3 block w-full text-center font-averta text-aurora text-sm'>Realize o login para acessar</strong>
                <form className="mt-2" onSubmit={handleSubmit(onSubmit)}>
                    <input {...register('login', { required: true })} type="text" id="login" className="w-full h-14 p-2 border rounded-t-lg font-averta text-sm outline-none" placeholder="Login" aria-label="login" />
                    <input {...register('password', { required: true })} type="password" id="password" className="w-full h-14 p-2 border rounded-b-lg font-averta text-sm outline-none" placeholder="Senha" aria-label="senha" />
                    <button type="submit" className="w-full h-14 bg-azul-claro text-white font-averta font-extrabold italic uppercase text-sm rounded-lg pt-1 mt-3">Entrar</button>
                </form>
                <div className="flex justify-center mt-4">
                    <button className="flex items-center gap-1 text-aurora text-sm font-averta " aria-label="ajuda" onClick={() => { toast.info('Procure a administração da Akiba') }}><IoIosHelpCircleOutline />Ajuda</button>
                </div>
            </div>
        </section>
    );
}

export default Auth;