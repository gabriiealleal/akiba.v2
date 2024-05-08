import useUsuarioLogado from '@/interfaces/private/hooks/useUsuarioLogado';

const BoasVindas = () => {
    const user = useUsuarioLogado();

    return (
        <section className="flex justify-center w-full">
            <div className="font-averta font-extrabold italic uppercase text-2xl text-center text-laranja border-4 border-azul-claro px-12 xl:px-20 py-2 rounded-xl">
                E ai {user?.nickname}, o quê que tem pra hoje?
            </div>
        </section>
    )
}

export default BoasVindas;