import { Link } from "react-router-dom";
import { FaEye, FaPenNib } from "react-icons/fa";
import useUsuarioLogado from "@/interfaces/private/hooks/useUsuarioLogado";
import { usePosts } from "@/services/posts/queries";
import UltimasMateriasError from "@/interfaces/private/placeholders/dashboard/ultimas_materias/UltimasMateriasError";
import UltimasMateriasLoading from "@/interfaces/private/placeholders/dashboard/ultimas_materias/UltimasMateriasLoading";

const UltimasMaterias = () => {
    const user = useUsuarioLogado();
    const { data: getPosts, isLoading, isError } = usePosts();

    if(isLoading){
        return <UltimasMateriasLoading />
    }else if(isError){
        return <UltimasMateriasError />
    }
    
    return (
        <section className="mt-8">
            <div className="title-default">
                <h1>Últimas matérias</h1>
            </div>
            <div className="mt-2 flex justify-center lg:justify-start gap-2 flex-wrap">
                {getPosts?.publicações.slice(0, 10).map((post: any, index:any) => (
                    <div key={index} className="bg-azul-claro w-full sm:w-1/4 xl:w-19.45% h-40 p-2 rounded-md">
                        <h1 className="h-71% text-aurora text-sm uppercase font-averta line-clamp-5">
                            {post.title}
                        </h1>
                        <div className="flex justify-between mt-5">
                            <span className="text-aurora font-averta font-extrabold italic uppercase">{post.author.nickname}</span>
                            <div className="flex gap-2">
                                <Link to="#" title="visualizar a postagem no site" className="text-aurora font-averta font-extrabold italic uppercase flex items-center gap-1">
                                    <FaEye className="text-aurora text-xl" />
                                </Link>
                                {user?.id === post.author.id && (
                                    <Link to={`/painel/materias/${post.slug}`} title="editar a postagem" className="text-aurora font-averta font-extrabold italic uppercase flex items-center gap-1">
                                        <FaPenNib className="text-aurora" />
                                    </Link>
                                )}
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </section>
    );
}

export default UltimasMaterias;