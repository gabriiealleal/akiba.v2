import { useParams } from 'react-router-dom';
import { usePost } from '@/services/posts/queries';
import TituloDaMateriaLoading from "@/interfaces/private/placeholders/materias/TituloDaMateriaLoading"

const TituloDaMateria = () => {
    const { slug } = useParams();
    const { data: getPost, isLoading } = usePost(slug ?? "");
    const postagem = getPost?.publicação;

    if(slug){
        if(isLoading){
            return <TituloDaMateriaLoading />
        }
    }

    return (
        <div className="mb-6">
            <label htmlFor="titulo" className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Título</label>
            <input type="text" id="titulo" name="titulo" className="w-full h-10 rounded-md p-2 outline-none font-averta" defaultValue={postagem?.title} />
        </div>
    )
}

export default TituloDaMateria;